const express = require('express');
const auth = require('./auth');

const app = express();
app.use(express.json());

app.post('/register', auth.register);
app.post('/login', auth.login);

app.listen(3000, () => {
  console.log('Server listening on port 3000');
});
