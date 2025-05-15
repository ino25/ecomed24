const express=require("express");
const {getAllStocks,addStock,updateStock,deleteStock,getStockById}=require("../controllers/stockManagement.controller");
const router=express.Router();

router.get("/getAllStocks",getAllStocks);
module.exports = router;