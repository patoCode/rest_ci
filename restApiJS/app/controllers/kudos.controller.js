var amqp = require('amqplib/callback_api');
const Kudos = require('../models/kudos.model.js');

// Create  
exports.create = (req, res) => {    
    if(!req.body) {
        return res.status(400).send({
            message: "kudos no puede estar vacio"
        });
    }
    const kudos = new Kudos({
        fuente: req.body.fuente,
        fuenteName: req.body.fuenteName, 
        destino:req.body.destino,
        destinoName:req.body.destinoName,
        tema:req.body.tema,
        lugar:req.body.lugar,
        texto:req.body.text || "No text"
    });
    kudos.save().then(data => {
        amqp.connect('amqp://10.241.22.191:5672', function(error0, connection) {
            if (error0) {
                throw error0;
              }
              connection.createChannel(function(error1, channel) {
                if (error1) {
                  throw error1;
                }
                var queue = 'BBDD';
                var msg = 'Hello COLA DESDE NODEJS';
            
                channel.assertQueue(queue, {
                  durable: false
                });
            
                channel.sendToQueue(queue, Buffer.from(msg));
                console.log(" [x] Sent %s", msg);
              });
        });
        res.send(data);
    }).catch(err => {
        res.status(500).send({
            message: err.message || "Error mientras se creaba el KUDOS."
        });
    });
};

// LIST
exports.findAll = (req, res) => {
    Kudos.find().then( kudos => {
        res.send(kudos);
    }).catch(err => {
        res.status(500).send({
            message: err.message || "Some error occurred while retrieving Kudos."
        });
    });

};

// Find
exports.findOne = async (req, res) => {    
    const { kudosId } = req.params
    const listKudos = await Kudos.find({destino:kudosId}).sort({fecha:'desc'})
	res.send(listKudos)
}

// Update
exports.update = (req, res) => {    
}

// Delete
exports.delete = (req, res) => {
    Kudos.findByIdAndRemove(req.params.kudosId)
    .then(kudos => {
        if(!kudos) {
            return res.status(404).send({
                message: "kudos no encontrado con el id " + req.params.kudosId
            });
        }
        res.send({message: "kudos eliminado"});
    }).catch(err => {
        if(err.kind === 'ObjectId' || err.name === 'NotFound') {
            return res.status(404).send({
                message: "kudos no encontrado con el id " + req.params.kudosId
            });                
        }
        return res.status(500).send({
            message: "No es posible borrar el kudos" + req.params.kudosId
        });
    });

};