from werkzeug.middleware.dispatcher import DispatcherMiddleware
from werkzeug.serving import run_simple

from routes import server as flask_app
from dash_demo import app as dash_app

# dash_app.enable_dev_tools(debug=True)

application = DispatcherMiddleware(flask_app, {
    '/dashboard': dash_app.server,
})

if __name__ == '__main__':
    run_simple('localhost', 8050, application, use_debugger=True, use_evalex=True)