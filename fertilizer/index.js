const express = require('express')
const app = express()
const port = 3000
const queryFn = require('./scrapper');

app.use(express.static('public'))

app.get('/search', function (req, res) {
    res.setHeader("Access-Control-Allow-Origin", "*")
    if (Object.keys(req.query).length && req.query.key) {

        queryFn(req.query.key).then(function (arr) {
            res.send({
                success: true,
                result: arr
            })
        }).catch(function () {
            res.send({
                success: false,
                error: "Something Went Wrong"
            })
        })

        return false;
    }

    res.send({
        success: false
    })
})

app.listen(port, () => {
    console.log(`Example app listening at http://localhost:${port}`)
})