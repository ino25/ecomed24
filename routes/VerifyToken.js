require('dotenv/config');
const jwt = require('jsonwebtoken');
// const user = require('../models/User');
const User = require('../models/User');

async function verifyToken(req, res, next) {
    let token = req.headers['x-access-token'] || req.headers['authorization'];

    // Vérifier que le token existe
    if (!token) {
        return res.status(401).json({ status: 0, message: 'No token provided.' });
    }

    // Supprimer le préfixe Bearer si présent
    if (token.startsWith('Bearer ')) {
        token = token.slice(7);
    }

    try {
        // Vérifier la validité du token
        const decoded = jwt.verify(token, process.env.SECRET, { algorithm: 'HS256' });

        // Attacher les infos utilisateur au request
        req.userId = decoded.id;
        req.org_id = decoded.org_id;
        req.role_id = decoded.role_id;
        req.email = decoded.email;

        next(); // Continuer vers la route suivante
    } catch (err) {
        // En cas d'échec, nettoyer le token dans la base
        const td = jwt.decode(token); // tenter de décoder partiellement

        if (td?.id && td?.org_id) {
            await User.update(
                { token: null },
                { where: { id: td.id, id_organisation: td.org_id, active: 1 } }
            );
        }

        return res.status(401).json({ status: 0, message: 'Failed to authenticate token.' });
    }
}

module.exports = verifyToken;
