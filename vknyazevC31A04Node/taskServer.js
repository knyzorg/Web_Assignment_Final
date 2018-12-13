const http = require("http");
const path = require("path");
const fs = require("fs");
const url = require("url");
const request = require("request");
const Mustache = require("Mustache");

const publicRoot = path.join(__dirname, "./public");


const defaultDocuments = ["index.html"];

let extensions = {
    ".html": "text/html",
    ".css": "text/css",
    ".js": "application/javascript",
    ".png": "image/png",
    ".jpg": "image/jpeg",
    ".jpeg": "image/jpeg",
    ".gif": "image/gif",
    ".pdf": "application/pdf",
    ".svg": "image/svg+xml",
    ".xml": "text/xml",
    ".txt": "text/plain",
    ".ico": "image/x-icon",
    ".json": "application/json"
};

http.createServer(async (req, res) => {

    // Normalize against directory traversal attack by reducing them to `/`
    let requestedPath = path.join("/", req.url);
    let parsedPath = path.parse(requestedPath);
    let mimeType = extensions[parsedPath.ext];

    res.writeHead(200, {
        "Content-Type": mimeType || extensions[".html"]
    })

    // Task controller
    if (req.url.startsWith("/list/")) {
        let statusCode = req.url.replace("/list/", "");
        return request("http://csdev.cegep-heritage.qc.ca/Students/1735714/C31A04PHP/getTaskInfo.php?status=" + statusCode, (err, response) => {

            return res.end(response.body);
        });
    } else if (req.url.startsWith("/task/")) {
        let id = req.url.replace("/task/", "");
        return request("http://csdev.cegep-heritage.qc.ca/Students/1735714/C31A04PHP/getTaskDetail.php?id=" + id, (err, response) => {
            fs.readFile("./public/open.mst", (err, data) => {
                return res.end(Mustache.render(data.toString(), { ...JSON.parse(response.body),
                    updateFormat: function () {
                        return new Date(this.dateUpdated*1000).toString()
                    },
                    createFormat: function () {
                        return new Date(this.dateUpdated*1000).toString()
                    }
                }));
            })

        });
    }


    // `/public` controller




    // Join with webroot and read file
    fs.readFile(path.join(publicRoot, requestedPath), (err, data) => {
        if (err) {


            return fs.readFile(path.join(publicRoot, "index.html"), (err, data) => {
                res.end(data);
            })
        }



        res.end(data);

    })

}).listen(7654);