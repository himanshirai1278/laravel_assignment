// Simple Echo setup with Pusher-compatible Laravel Websockets
import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: document.querySelector('meta[name="pusher-key"]')?.content || 'app-key',
  wsHost: window.location.hostname,
  wsPort: 6001,
  forceTLS: false,
  disableStats: true,
  authorizer: (channel, options) => {
    return {
      authorize: (socketId, callback) => {
        fetch('/broadcasting/auth', {
          method: 'POST',
          headers: {'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},
          body: JSON.stringify({ socket_id: socketId, channel_name: channel.name })
        }).then(res => res.json()).then(data => callback(false, data)).catch(err => callback(true, err));
      }
    };
  }
});

window.listenOrderChannel = function(customerId){
  window.Echo.private('orders.'+customerId)
    .listen('.OrderStatusUpdated', (e)=>{
      alert('Order '+e.orderId+' is now '+e.status);
    });
};

window.initPresence = function(){
  window.Echo.join('presence.admin-dashboard')
    .here(users => { document.getElementById('presence').innerText = 'Online: '+users.length; })
    .joining(user => {})
    .leaving(user => {});
};
