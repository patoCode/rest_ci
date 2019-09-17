const mongoose = require('mongoose');

const KudosSchema = mongoose.Schema({
    title: String,
    content: String
}, {
    timestamps: true
});

module.exports = mongoose.model('Kudos', KudosSchema);