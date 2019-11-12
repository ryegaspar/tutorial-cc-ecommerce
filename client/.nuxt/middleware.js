const middleware = {}

middleware['redirectIfAuthenticated'] = require('../middleware/redirectIfAuthenticated.js');
middleware['redirectIfAuthenticated'] = middleware['redirectIfAuthenticated'].default || middleware['redirectIfAuthenticated']

middleware['redirectIfGuest'] = require('../middleware/redirectIfGuest.js');
middleware['redirectIfGuest'] = middleware['redirectIfGuest'].default || middleware['redirectIfGuest']

export default middleware
