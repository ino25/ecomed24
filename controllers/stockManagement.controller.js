const Stock = require('../models/StockMangements');
exports.getAllStocks=async(req,res)=>{
    try{
        const stocks = await Stock.findAll({
            attributes: ['id', 'drugId'],
            // where: {
            //     status: "active"
            // },
            // order: [['id', 'DESC']]
        });
        console.log("Fetched stocks:", stocks);
        if(!stocks || stocks.length === 0){
             return res.json({
            status: 0,
            message: "No Stocks found",
            data: [],
      });
        }
        return res.json({
      status: 1,
      message: "List of Stocks",
      data: stocks,
    });
    }catch(err){
        console.error("Error fetching stocks:", err);
        res.status(500).json({ message: "Internal server error" });
    }
}