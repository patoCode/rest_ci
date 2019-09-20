const amqp = require('amqplib/callback_api')
const rbbConfig = require('../../config/rabbit.config.js')
const Kudos = require('../models/kudos.model.js');
const _self = this;
// Create  
exports.create = async (req, res) => {
    var queueUser = "QUEUE-"
    if (!req.body) {
        return res.status(400).send({
            message: "kudos no puede estar vacio"
        })
    }
    const kudos = new Kudos({
        fuente: req.body.fuente,
        fuenteName: req.body.fuenteName,
        destino: req.body.destino,
        destinoName: req.body.destinoName,
        tema: req.body.tema,
        lugar: req.body.lugar,
        texto: req.body.text || "No text"
    })
    await kudos.save()
    queueUser = "QUEUE-" + kudos.destino

    // RABBIT SUMA LOS KUDOS CON AYUDA DEL STATS
    amqp.connect(rbbConfig.url, function (error0, connection) {
        connection.createChannel(function (error1, channel) {
            channel.assertQueue('', {
                exclusive: true
            }, (err, q) => {
                if (err)
                    throw err

                var correlationId = generateUuid()
                var fuente = kudos.fuente
                channel.consume(q.queue, (msg) => {
                    if (msg.properties.correlationId == correlationId) {
                    }
                }, { noAck: true })
                channel.sendToQueue(rbbConfig.queueStats,
                    Buffer.from(fuente.toString()), {
                        correlationId: correlationId,
                        replyTo: q.queue
                    })
            })
        })
    })
    // END RABBIT

    // RABBIT PUBLICA KUDOS DEL USUARIO
    amqp.connect(rbbConfig.url, (error0, connection) => {
        connection.createChannel((error1, channel) => {
            channel.assertQueue(queueUser, {
                durable: true
            })
            channel.prefetch(1)
            channel.consume(queueUser, async function reply(msg) {
                var n = msg.content.toString()
                var r = await _self.findOneRbb(n)
                channel.sendToQueue(msg.properties.replyTo,
                    Buffer.from(JSON.stringify(r)), {
                        correlationId: msg.properties.correlationId
                    })
                channel.ack(msg)
            })
        })
    })
    // FIN RABBIT    

    res.redirect('/stats/add')
}

// LIST
exports.findAll = async (req, res) => {
    const kudos = await Kudos.find()
    res.send(kudos)
};

// Find
exports.findOne = async (req, res) => {
    const { kudosId } = req.params
    const listKudos = await Kudos.find({ destino: kudosId }).sort({ fecha: 'desc' })
    res.send(listKudos)
}

exports.findOneRbb = async (id) => {
    console.log(id)
    var listKudos = await Kudos.find({ destino: id }).sort({ fecha: 'desc' })
    return listKudos
}

// Update   
exports.update = (req, res) => {
}

// Delete
exports.delete = async (req, res) => {
    const { _id } = req.params
    const kudosReg = await Kudos.findById(_id)
    console.log(kudosReg)
    await Kudos.findOneAndDelete(_id)
    // INIT RABBIT
    amqp.connect(rbbConfig.url, function (error0, connection) {
        connection.createChannel(function (error1, channel) {
            channel.assertQueue('', {
                exclusive: true
            }, (err, q) => {
                if (err)
                    throw err
                var correlationId = generateUuid()
                var fuente = kudosReg.fuente
                channel.consume(q.queue, (msg) => {
                    if (msg.properties.correlationId == correlationId) {
                    }
                }, { noAck: true })
                channel.sendToQueue(rbbConfig.queueStatsDel,
                    Buffer.from(fuente.toString()), {
                        correlationId: correlationId,
                        replyTo: q.queue
                    })
            })
        })
    })
    // END RABBIT
    res.redirect('/stats/remove')
}

exports.deleteMasive = async (id) => {
    const result = await Kudos.remove({ destino: id })
    return "ok";
}

function generateUuid() {
    return Math.random().toString() +
        Math.random().toString() +
        Math.random().toString();
}