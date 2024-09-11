require('dotenv/config');
const jwt = require('jsonwebtoken');
// const user = require('../models/User');
var User = require('../models/User');
async function verifyToken(req, res, next) {
    var token = req.headers['x-access-token'] || req.headers['authorization'];
    if (token.startsWith('Bearer ')) {
        // Remove Bearer from string
        token = token.slice(7, token.length);
    }

    if (!token)
        return res.json({ status: 0, message: 'No token provided.' });

    jwt.verify(token, process.env.SECRET, { algorithm: 'HS256' }, async (err, decoded) => {
        if (err) {
            const td = jwt.decode(token);
            // Set User Logout Flag
            await User.update({ token: null, }, { where: { id: td.id, id_organisation: td.org_id, active: 1 } });
            return res.status(401).json({ status: 0, message: 'Failed to authenticate token.' });
        }
        console.log(decoded);
        // if everything good, save to request for use in other routes
        req.userId = decoded.id;
        req.org_id = decoded.org_id;
        req.role_id = decoded.role_id;
        req.email = decoded.email;
        next();
    });
}

module.exports = verifyToken;