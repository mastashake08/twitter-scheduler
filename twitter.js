require('dotenv').config()
var Twit = require('twit')

var T = new Twit({
  consumer_key:         process.env.TWITTER_CONSUMER_KEY,
  consumer_secret:      process.env.TWITTER_CONSUMER_SECRET,
  access_token:         process.env.TWITTER_ACCESS_TOKEN,
  access_token_secret:  process.env.TWITTER_ACCESS_TOKEN_SECRET,
  timeout_ms:           60*1000,  // optional HTTP request timeout to apply to all requests.
})

var stream = T.stream('user');
stream.on('connected', function(response){
  console.log('Connected!')
});
stream.on('follow',function(data){
 console.log(data.source.id);
  T.post('direct_messages/events/new',{
  "event": {
    "type": "message_create",
    "message_create": {
      "target": {
        "recipient_id": data.source.id
      },
      "message_data": {
        "text": "Thanks for the follow! Be sure to check out my blog https://jyroneparker.com",
      }
    }
  }
})

});