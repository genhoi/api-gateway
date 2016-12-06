local lapis = require("lapis")
local http = require("lapis.nginx.http")
local app = lapis.Application()

app:match("/", function(self)

    local buf = {};
    buf[1] = http.simple("http://openresty_hello");
    buf[2] = ", ";
    buf[3] = http.simple("http://openresty_world");

    return { table.concat(buf), status = 200, headers = {}, render = false, layout = false }

end)

return app
