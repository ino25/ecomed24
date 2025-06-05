require('dotenv').config();

console.log("DB:", process.env.DB_NAME);
console.log("USER:", process.env.DB_USER);
console.log("PASS:", process.env.DB_PASS);
console.log("HOST:", process.env.DB_HOST);

const { Sequelize } = require('sequelize');

const sequelize = new Sequelize(
  process.env.DB_NAME,
  process.env.DB_USER,
  process.env.DB_PASS,
  {
    host: process.env.DB_HOST,
    dialect: 'mysql',
    port: 3307
  }
);

async function testConnection() {
  try {
    await sequelize.authenticate();
    console.log('✅ Connection has been established successfully.');
  } catch (error) {
    console.error('❌ Unable to connect to the database:', error);
  }
}

testConnection();
