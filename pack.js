const packs = [
    {
      name: 'Basic Pack',
      price: 100,
      cards: [
        { name: 'Card 3', rarity: 'common', probability: 0.7 },
        { name: 'Card 4', rarity: 'rare', probability: 0.2 },
        { name: 'Card 5', rarity: 'epic', probability: 0.05 },
        { name: 'Card 6', rarity: 'legendary', probability: 0.01 },
      ],
    },
  ];
  
  function openPack(packName) {
    const pack = packs.find((p) => p.name === packName);
    if (!pack) {
      throw new Error(`Pack "${packName}" not found`);
    }
  
//   -----------------------------------
//   -----------------------------------

    // check if user has enough credits to buy the pack
    if (user.credits < pack.price) {
      throw new Error('Insufficient credits to buy this pack');
    }

//   -----------------------------------
//   -----------------------------------    
  
    // deduct the pack price from user's credits
    user.credits -= pack.price;

//   -----------------------------------
//   -----------------------------------    
  
    // generate random cards based on probabilities
    const cards = [];
    for (const card of pack.cards) {
      if (Math.random() < card.probability) {
        cards.push(card.name);
      }
    }

//   -----------------------------------
//   -----------------------------------    
  
    // add the new cards to user's collection
    user.collection.push(...cards);

//   -----------------------------------
//   -----------------------------------    
  
    // return the new cards as a response
    return { cards };
  }
  