function feedbackSubmitted() {
    alert("We have received your message and will get back to you as soon as possible! Thank you!");
}

function nameCheck(id) {
    let x = document.getElementById(id);
    let regexp = /^[A-Za-z\s]*$/;

    if (!regexp.test(x.value)) {
        alert("Your name should only contain alphabet characters and character spaces. Please try again.");
        x.value = '';
    }
}

function emailCheck(id) {
    let x = document.getElementById(id);
    let regexp = /^[\w.-]+@(\w+\.){1,3}(\w){2,3}$/;

    if (x.value.length > 0 && !regexp.test(x.value)) {
        alert("Your email address is badly formatted. Please try again.");
        x.value = '';
    }
}

function cardnumCheck(id) {
    let x = document.getElementById(id);
    let regexp = /^[0-9\s]*$/;

    if (!regexp.test(x.value)) {
        alert("Numbers and spaces only. Please try again.");
        x.value = '';
    }
}

function CVVCheck(id) {
    let x = document.getElementById(id);
    let regexp = /^[0-9]*$/;

    if (!regexp.test(x.value)) {
        alert("Please input 3 digits only. Try again.");
        x.value = '';
    }
}

let arr = [0, 0, 0, 0];    // index 0 holds the tea selection price, index 1 holds the addon(s) prices, index 2 holds sugar level price, index 3 holds ice level price 

function inittotalDIY(priceTea, priceSugarLevel, priceIceLevel) {
    let totalDIYprice = priceTea + priceSugarLevel + priceIceLevel;
    document.getElementById("DIYdrinkPrice").innerHTML = "$" + totalDIYprice.toFixed(2);
    arr[0] = priceTea;
    arr[2] = priceSugarLevel;
    arr[3] = priceIceLevel;
}

function calctotalDIY(teaSelectionprice, addonSelectionprice, id) {
    if (teaSelectionprice != null && addonSelectionprice == null) {
        arr[0] = teaSelectionprice;
    }
    if (teaSelectionprice == null && addonSelectionprice != null) {
        if (document.getElementById(id).checked) {
            arr[1] += addonSelectionprice;
        }
        else {
            arr[1] -= addonSelectionprice;
        }
    }
    document.getElementById("DIYdrinkPrice").innerHTML = "$" + (arr[0] + arr[1] + arr[2] + arr[3]).toFixed(2);
}

function calctotalDIY2(SugarIceSelectionprice, name) {
    if (name == "sugarlevel") {
        arr[2] = SugarIceSelectionprice;
    }
    else {
        arr[3] = SugarIceSelectionprice;
    }
    document.getElementById("DIYdrinkPrice").innerHTML = "$" + (arr[0] + arr[1] + arr[2] + arr[3]).toFixed(2);
}

function qtycheck(id, qty) {
    let x = document.getElementById(id);

    if (x.value > qty) {
        alert("Invalid input. Input a smaller quantity.");
        x.value = '';
    }
}

function handleDataSelect(id) {
    let x = document.getElementById(id);

    if (x.value == "orderdetails") {
        document.getElementById("orderdetailsnumber").style.display = 'inline';
    }
    else {
        document.getElementById("orderdetailsnumber").style.display = 'none';
    }
}