const DepenseType = require('../models/DepenseType');

//  Récupérer tous les types de dépense
const getAllDepenseTypes = async (req, res) => {
  try {
    const page = parseInt(req.query.page) || 1;
    const limit = parseInt(req.query.limit) || 10;
    const offset = (page - 1) * limit;

    const { count, rows } = await DepenseType.findAndCountAll({
      order: [['createdAt', 'DESC']],
      offset,
      limit
    });

    return res.status(200).json({
      total: count,
      page,
      limit,
      data: rows
    });
  } catch (err) {
    console.error("💥 Erreur récupération liste dépense :", err);
    return res.status(500).json({ error: 'Erreur serveur lors de la récupération.' });
  }
};

const getOneDepenseType = async (req, res) => {
  try {
    const id = req.params.id;

    const depenseType = await DepenseType.findByPk(id);

    if (!depenseType) {
      return res.status(404).json({ error: "Type de dépense non trouvé." });
    }

    return res.status(200).json(depenseType);
  } catch (err) {
    console.error("💥 Erreur récupération type de dépense :", err);
    return res.status(500).json({ error: "Erreur serveur lors de la récupération." });
  }
};


const createDepenseType = async (req, res) => {
  try {
    console.log("🔍 Corps de la requête :", req.body); // Vérifie les données reçues

    const { libelle, description } = req.body;

    if (!libelle?.trim()) {
      console.warn("❌ Libellé manquant");
      return res.status(400).json({ error: 'Libellé requis.' });
    }

    const created_by = req.userId;
    console.log("👤 ID utilisateur connecté (created_by) :", created_by); // Vérifie si le token a bien injecté l’ID

    if (!created_by) {
      console.error("❌ Aucun utilisateur authentifié");
      return res.status(401).json({ error: "Authentification requise." });
    }

    const depenseType = await DepenseType.create({
      libelle: libelle.trim(),
      description: description?.trim() || null,
      created_by
    });

    console.log("✅ Dépense créée avec succès :", depenseType);
    res.status(201).json(depenseType);

  } catch (err) {
    console.error("💥 Erreur création dépense :", err); // Affiche la vraie erreur côté serveur
    res.status(500).json({ error: 'Erreur lors de la création.' });
  }
};


// ✏️ Mettre à jour un type de dépense
const updateDepenseType = async (req, res) => {
  try {
    const { libelle, description } = req.body;
    const depenseType = await DepenseType.findByPk(req.params.id);

    if (!depenseType) {
      return res.status(404).json({ error: 'Type de dépense non trouvé.' });
    }

    await depenseType.update({
      libelle: libelle?.trim() || depenseType.libelle,
      description: description?.trim() || depenseType.description,
      last_updated_by: req.userId || null
    });

    return res.status(200).json(depenseType);
  } catch (err) {
    console.error("💥 Erreur mise à jour type de dépense :", err);
    return res.status(500).json({ error: 'Erreur lors de la mise à jour.' });
  }
};

const deleteDepenseType = async (req, res) => {
  try {
    const depenseType = await DepenseType.findByPk(req.params.id);
    if (!depenseType) {
      return res.status(404).json({ error: 'Type de dépense non trouvé.' });
    }

    await depenseType.destroy();
    return res.status(204).end();
  } catch (err) {
    console.error("💥 Erreur suppression type de dépense :", err);
    return res.status(500).json({ error: 'Erreur lors de la suppression.' });
  }
};




module.exports = {
  getAllDepenseTypes,
  getOneDepenseType,
  createDepenseType,
  updateDepenseType,
  deleteDepenseType
};
