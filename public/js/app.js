function addEventListeners() {
    let form = document.querySelector(".editAuction");
    if (form != null) {
        var input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("id", "force_edit");
        input.setAttribute("value", 1);
        form.appendChild(input);
    }

    let imageDeleters = document.querySelectorAll(".editAuction a.image_delete");
    [].forEach.call(imageDeleters, function (deleter) {
        deleter.addEventListener("click", sendDeleteImageRequest);
    });

    addListenerPageReports();

    addListenerPageUsers();
}

function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data)
        .map(function (k) {
            return encodeURIComponent(k) + "=" + encodeURIComponent(data[k]);
        })
        .join("&");
}

function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();

    request.open(method, url, true);
    request.setRequestHeader(
        "X-CSRF-TOKEN",
        document.querySelector('meta[name="csrf-token"]').content
    );
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.addEventListener("load", handler);
    request.send(encodeForAjax(data));
}

function sendDeleteImageRequest() {
    let input = document.querySelector(".editAuction #force_edit");
    input.setAttribute('value', 3);
    console.log(input.getAttribute('value'));
    let id = this.getAttribute("data-id");
    console.log(id);
    sendAjaxRequest("delete", "/api/images/" + id, null, imageDeletedHandler);
}

function imageDeletedHandler() {
    if (this.status != 200)
        console.log(this);
    let item = JSON.parse(this.responseText);
    let element = document.querySelector('a[data-id="' + item.id + '"]');
    element.remove();
}

function addListenerPageReports() {
    let paginationReports = document.querySelectorAll(".reports .pagination a");
    [].forEach.call(paginationReports, function (page) {
        page.addEventListener("click", loadPageReports);
    });
}

function loadPageReports(event) {
    event.preventDefault();
    let url = this.getAttribute('href');
    let page = url.split("page=")[1];
    url = "admin/reports?page=" + page;
    sendAjaxRequest("get", url, null, pageReportsHandler);
}

function pageReportsHandler() {
    if (this.status != 200)
        console.log(this);
    let element = document.querySelector('.reports');
    element.innerHTML = this.responseText;
    addListenerPageReports();
}

function addListenerPageUsers() {
    let paginationUsers = document.querySelectorAll(".users .pagination a");
    [].forEach.call(paginationUsers, function (page) {
        page.addEventListener("click", loadPageUsers);
    });
}

function loadPageUsers(event) {
    event.preventDefault();
    let url = this.getAttribute('href');
    let page = url.split("page=")[1];
    url = "admin/users?page=" + page;
    sendAjaxRequest("get", url, null, pageUsersHandler);
}

function pageUsersHandler() {
    if (this.status != 200)
        console.log(this);
    let element = document.querySelector('.users');
    element.innerHTML = this.responseText;
    addListenerPageUsers();
}

addEventListeners();
