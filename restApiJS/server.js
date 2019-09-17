const express = require('express')
const bodyParser = require('body-parser')
const morgan = require('morgan')
const mongoose = require('mongoose')

const dbConfig = require('./config/database.config.js')

// INIT
const app = express()

// DATABASE
mongoose.connect(dbConfig.url, {
    useNewUrlParser: true,
    useUnifiedTopology: true
})
.then(db=> console.log('DB is connect'))
.catch(err => console.error(err));

// SETTINGS
app.set('port', process.env.PORT || 5002);
mongoose.Promise = global.Promise;

// MIDDLEWARE
app.use(bodyParser.json())
app.use(morgan('dev'));
app.use(bodyParser.urlencoded({ extended: true }))


// ROUTES
app.get('/', (req, res) => {
    res.json({"message": "Welcome to EasyNotes application. Take notes quickly. Organize and keep track of all your notes."});
});

require('./app/routes/kudos.routes.js')(app);

// INIT SERVER 
app.listen(app.get('port'),() => {
	console.log(`SERVER ON PORT ${app.get('port')}`);
})