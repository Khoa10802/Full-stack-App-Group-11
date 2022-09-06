// REFERENCES:
// https://www.javascripttutorial.net/dom/manipulating/iterate-over-selected-elements/
// https://www.w3schools.com
// https://www.geeksforgeeks.org/how-to-add-html-elements-dynamically-using-javascript/
// https://www.geeksforgeeks.org/remove-an-element-at-specific-index-from-an-array-in-java/

cart_items = []
const cart_items_keys = "cart_items"

loadCart()

function add2cart(in_name, in_price, in_description, in_image) {
    let itm = {
        name : in_name,
        price : in_price,
        description : in_description,
        image : in_image
    }
    cart_items.push(itm);
    // alert("Added");
    saveCart();
}

function removefromcart(delete_item) {
    let temp = [];
    for (let i = 0, k = 0; i < cart_items.length; i++) {
        if (i == delete_item) {
            continue;
        }
        temp[k++] = cart_items[i];
    }
    cart_items = temp;
    saveCart();
    location.reload()
}

document.getElementsByTagName('body').addEventListener('onload', load_itm_list())

// UI NOTE: This function is used to format HTML for DIV.cart, can be changed or FLEX
// UI NOTE: Recommended to use browser's inspect element mode to design the UI (to see the HTML structure)
function load_itm_list() {
    for (let itm of cart_items) {
        document.querySelector(".cart").innerHTML += "<div class=\"item\">" + "<h2>" + itm['name'];
    }
    const items = document.querySelectorAll(".item");
    const len = items.length;
    for (let i = 0; i < len; i++) {
        // UI NOTE: The name of item is a h2 instead, can be changed if needed
        items[i].innerHTML += "<div class=\"item-image\">" + "<img src=\"items/" + cart_items[i]['image'] + 
        "\" alt=\"Image missing\" width=\"200\" height=\"200\">"; // <--- Images resolution here, delete if use CSS
        items[i].innerHTML += "<div class=\"demo\">";
    }
    const div = document.querySelectorAll(".demo");
    const count = div.length;
    for (let i = 0; i < count; i++) {
        div[i].innerHTML += "<div class=\"item-description\">" + cart_items[i]['description'];
        div[i].innerHTML += "<div class=\"item-price\">" + cart_items[i]['price'];
        div[i].innerHTML += "<div class=\"remove_btn\">" + 
        "<input type=\"submit\" value=\"Remove from cart\" id=\"remove_btn\" onclick=\"removefromcart('" + i + "')\">";
    }
}

function saveCart() {
    localStorage.setItem(cart_items_keys, JSON.stringify(cart_items))
}

function loadCart() {
    cart_items = JSON.parse(localStorage.getItem(cart_items_keys));
    if (cart_items == null) {
        cart_items = [];
    }
}

function clearCart() {
    localStorage.clear();
}

function urlchange() {
    const len = cart_items.length;
    let url = "/shoppingcart.php?items=";
    if (len > 0) {
        let buffer_arr = [];
        for (let i = 0; i < len; i++) {
            buffer_arr.push(cart_items[i]['name']);
        }
        url += buffer_arr;
        url += "&order_btn=Order";
    }
    location.href = url;
    clearCart();
}
