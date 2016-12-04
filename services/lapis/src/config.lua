local config = require("lapis.config")

config({"development", "production"}, {
    port = "80",
    dns_server = "127.0.0.11",

    num_workers = "1",

    email_enabled = false,
    code_cache = "off",
})

config("production", {
    email_enabled = true,
    code_cache = "on"
})
