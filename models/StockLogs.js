const { sequelize } = require("../config");

const StockLogs=sequelize.define('StockLogs', {
    id: {
       type: DataTypes.INTEGER,
       primaryKey: true,
       autoIncrement: true
     }, 
})

    