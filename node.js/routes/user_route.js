var express = require('express');
var router = express.Router();

var sendMail = require('../controller/SendMail');

router.get('/sendmail', sendMail.SendEmail);

module.exports = router;