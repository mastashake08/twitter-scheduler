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
        "text": "Thanks for the follow! Be sure to check out my blog https://jyroneparker.com I have many code tutorials and entrepreneur pieces! Also please subscribe to my Youtube channel and tune in to my live streams https://youtube.com/c/jyroneparker",
      }
    }
  }
})

});

var filter = T.stream('statuses/filter',{track: ['#30days30sites','#100DaysOfCode','#301DaysOfCode','#Webapp','#laravel','#vuejs','#techtalk','php','vuejs','vue.js','tech talk', '#php', 'c++', 'java', 'android', 'ios', 'objective-c', 'python', 'django',
'raspberry pi', 'programming', 'computer science', 'wep app', 'mobile app', 'nativescript','angularjs','react.js','reactjs',
'angular.js','webrtc', 'cryptocurrency', '#neo', '#rpx', 'ICO', '#ico', 'nep-5']});
filter.on('tweet',function(tweet){


  T.post('favorites/create', { id: tweet.id_str },function(data){
    console.log(data);
  });

});
