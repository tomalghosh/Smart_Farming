var card = {
    getRawHtml: function (obj) {
        var html = `
                <div class="card my-5">
                    <img class="card-img-top" src="${obj.img}" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text">${obj.name}</p>
                        <h5 class="card-title">${obj.price}</h5>
                        <h6 class="mb-3">${obj.source}</h6>
                        <a href="${obj.link}" class="btn btn-primary">Buy</a>
                    </div>
                </div>
            `;

        return html
    },

    getHtml: function (arr, parent) {
        var _this = this;

        return arr.forEach(function (obj) {
            var node = document.createElement("div");
            node.classList.add("col-3");
            node.innerHTML = _this.getRawHtml(obj);

            parent.appendChild(node);
        })
    }
}

var spinner = document.querySelector(".spinner-border");

function toggleLoader(status){
    if(status){
        spinner.style.display = "block"
    }
    else{
        spinner.style.display = "none"
    }
}

function request(method, url, callback) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            callback(JSON.parse(xhttp.responseText))
        }
    };
    xhttp.open(method, url, true);
    xhttp.send();
}


var productList = document.querySelector(".product-list");

var form = document.querySelector(".crop-form");


form.addEventListener("submit", function (e) {
    e.preventDefault();
    var queryValue = document.querySelector("#crop").value;

    toggleLoader(true);
    request("get", `/search?key=${queryValue}`, function (res) {
        productList.innerHTML = "";
        card.getHtml(res.result,productList);
        toggleLoader()
    })

})