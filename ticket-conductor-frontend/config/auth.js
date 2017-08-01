// auth.js
var passport = require("passport");  
var passportJWT = require("passport-jwt");  
const User = require("../models").User; 
var cfg = require("../config/config.js");  
var ExtractJwt = passportJWT.ExtractJwt;  
var Strategy = passportJWT.Strategy;  
var params = {  
  secretOrKey: cfg.jwtSecret,
  jwtFromRequest: ExtractJwt.versionOneCompatibility({authScheme: 'Bearer'})
};

module.exports = function() {  
  var strategy = new Strategy(params, function(payload, done) 
  {
    User.findById(payload.id).then(user => {
      if (user) {
        return done(null, {
          id: user.id
        });
      } else {
       return done(new Error("User not found"), null);
     }
     return done(null, user);
   });
  });
  passport.use(strategy);
  return {
    initialize: function() {
      return passport.initialize();
    },
    authenticate: function() {
      return passport.authenticate("jwt", cfg.jwtSession);
    }
  };
};
