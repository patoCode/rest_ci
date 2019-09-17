const Kudos = require('../models/kudos.model.js');

// Create  
exports.create = (req, res) => {
    // Validate request
    if(!req.body.content) {
        return res.status(400).send({
            message: "kudos content can not be empty"
        });
    }

    // Create 
    const ku2 = new Kudos({
        title: req.body.title || "Untitled Kudos", 
        content: req.body.content
    });

    // Save
    ku2.save()
    .then(data => {
        res.send(data);
    }).catch(err => {
        res.status(500).send({
            message: err.message || "Some error occurred while creating the Kudos."
        });
    });
};

// 
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
exports.findOne = (req, res) => {
    Kudos.findById(req.params.kudosId)
    .then(kudos => {
        if(!kudos) {
            return res.status(404).send({
                message: "Kudos not found with id " + req.params.kudosId
            });            
        }
        res.send(kudos);
    }).catch(err => {
        if(err.kind === 'ObjectId') {
            return res.status(404).send({
                message: "Kudos not found with id " + req.params.kudosId
            });                
        }
        return res.status(500).send({
            message: "Error retrieving Kudos with id " + req.params.kudosId
        });
    });

};

// Update
exports.update = (req, res) => {

     // Validate Request
     if(!req.body.content) {
        return res.status(400).send({
            message: "Kudos content can not be empty"
        });
    }

    // Find note and update it with the request body
    Kudos.findByIdAndUpdate(req.params.kudosId, {
        title: req.body.title || "Untitled Kudos",
        content: req.body.content
    }, {new: true})
    .then(kudos => {
        if(!kudos) {
            return res.status(404).send({
                message: "Kudos not found with id " + req.params.kudosId
            });
        }
        res.send(note);
    }).catch(err => {
        if(err.kind === 'ObjectId') {
            return res.status(404).send({
                message: "Kudos not found with id " + req.params.kudosId
            });                
        }
        return res.status(500).send({
            message: "Error updating Kudos with id " + req.params.kudosId
        });
    });

};

// Delete
exports.delete = (req, res) => {

    Kudos.findByIdAndRemove(req.params.kudosId)
    .then(kudos => {
        if(!kudos) {
            return res.status(404).send({
                message: "kudos not found with id " + req.params.kudosId
            });
        }
        res.send({message: "kudos deleted successfully!"});
    }).catch(err => {
        if(err.kind === 'ObjectId' || err.name === 'NotFound') {
            return res.status(404).send({
                message: "kudos not found with id " + req.params.kudosId
            });                
        }
        return res.status(500).send({
            message: "Could not delete kudos with id " + req.params.kudosId
        });
    });

};