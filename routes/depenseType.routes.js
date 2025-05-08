const express = require('express');
const router = express.Router();
const {
  getAllDepenseTypes,
  getOneDepenseType,
  createDepenseType,
  updateDepenseType,
  deleteDepenseType
} = require('../controllers/depenseTypeController');
const VerifyToken = require('./VerifyToken');

router.get('/', VerifyToken, getAllDepenseTypes);
router.get('/:id', VerifyToken, getOneDepenseType);
router.post('/', VerifyToken, createDepenseType);
router.put('/:id', VerifyToken, updateDepenseType);
router.delete('/:id', VerifyToken, deleteDepenseType);

module.exports = router;
