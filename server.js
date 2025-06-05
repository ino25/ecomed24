const { app } = require("./app");
const http = require("http");
const { Server } = require("socket.io");

const PORT = process.env.PORT || 7001;
const server = http.createServer(app);

const io = new Server(server, {
  cors: {
    origin: "*",
    methods: ["GET", "POST"],
  },
});

io.on("connection", (socket) => {
  console.log("✅ Utilisateur connecté :", socket.id);

  socket.on("join_room", (roomId) => {
    socket.join(roomId);
    console.log(`📦 Rejoint la salle : ${roomId}`);
  });

  socket.on("request_access", ({ roomId }) => {
    io.to(roomId).emit("access_request", { appointmentId: roomId });
  });

  socket.on("access_response", ({ appointmentId, accepted }) => {
    io.to(appointmentId).emit("access_response_result", {
      granted: accepted,
    });
  });

  socket.on("disconnect", () => {
    console.log("❌ Utilisateur déconnecté :", socket.id);
  });
});

server.listen(PORT, () => {
  console.log(`🚀 Serveur API + Socket.IO lancé sur http://localhost:${PORT}`);
});
