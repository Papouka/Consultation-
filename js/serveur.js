const WebSocket = require('ws');

const wss = new WebSocket.Server({ port: 8080 });

wss.on('connection', (ws) => {
    console.log('Un client est connecté');

    ws.on('message', (message) => {
        // Transmettez le message à tous les clients connectés
        wss.clients.forEach((client) => {
            if (client !== ws && client.readyState === WebSocket.OPEN) {
                client.send(message);
            }
        });
    });

    ws.on('close', () => {
        console.log('Un client s\'est déconnecté');
    });
});

console.log('Serveur WebSocket en écoute sur ws://localhost:8080');
