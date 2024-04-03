const jwt = require('jsonwebtoken');
const bcrypt = require('bcryptjs');

// Mock user database
const users = [];

// Function to generate a token for a user
function generateToken(user) {
  return jwt.sign({ id: user.id, email: user.email }, process.env.JWT_SECRET, {
    expiresIn: '24h',
  });
}

// Function to register a new user
async function register(req, res) {
  const { email, password } = req.body;


//   -----------------------------------
//   -----------------------------------

  // Check if user already exists
  const existingUser = users.find((user) => user.email === email);
  if (existingUser) {
    return res.status(400).send({ error: 'User already exists' });
  }

//   -----------------------------------
//   -----------------------------------

  // Hash the password
  const hashedPassword = await bcrypt.hash(password, 10);

//   -----------------------------------
//   -----------------------------------  

  // Create a new user
  const newUser = { id: users.length + 1, email, password: hashedPassword };
  users.push(newUser);

//   -----------------------------------
//   -----------------------------------  

  // Generate a token for the new user
  const token = generateToken(newUser);

//   -----------------------------------
//   -----------------------------------  

  // Send the token as a response
  res.status(201).send({ token });
}

//   -----------------------------------
//   -----------------------------------

// Function to log in an existing user
async function login(req, res) {
  const { email, password } = req.body;

//   -----------------------------------
//   -----------------------------------  

  // Check if user exists
  const user = users.find((user) => user.email === email);
  if (!user) {
    return res.status(400).send({ error: 'User not found' });
  }

//   -----------------------------------
//   -----------------------------------  

  // Check if password is correct
  const validPassword = await bcrypt.compare(password, user.password);
  if (!validPassword) {
    return res.status(400).send({ error: 'Invalid password' });
  }

//   -----------------------------------
//   -----------------------------------  

  // Generate a token for the user
  const token = generateToken(user);

//   -----------------------------------
//   -----------------------------------  

  // Send the token as a response
  res.send({ token });
}

module.exports = { register, login };
