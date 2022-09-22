var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/testing', function(req, res, next) {
  //res.render('index', { title: 'Express' });
  res.json({Data:"Holaaaa"})
});

module.exports = router;
