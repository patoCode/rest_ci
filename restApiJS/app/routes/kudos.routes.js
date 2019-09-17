module.exports = (app) => {
    const kudos = require('../controllers/kudos.controller.js');

    // Create
    app.post('/kudos', kudos.create);

    // Retrieve all
    app.get('/kudoss', kudos.findAll);

    // Retrieve a single 
    app.get('/kudos/:noteId', kudos.findOne);

    // Update
    app.put('/kudos/:noteId', kudos.update);

    // Delete
    app.delete('/kudos/:noteId', kudos.delete);
}