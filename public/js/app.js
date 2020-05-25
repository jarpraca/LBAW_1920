function addEventListeners() {
    $('body').tooltip({
        selector: '[data-toggle="tooltip"]'
    });

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

    let stopButton = document.querySelector("#stop_button");
    if (stopButton != null)
        stopButton.addEventListener("click", disableStopAuctionButton);

    let methodButton = document.querySelector('#method_button');
    if (methodButton != null)
        methodButton.addEventListener("click", saveMethods)

    let addwatchlistButton = document.querySelector(".addWatchlist");
    if(addwatchlistButton != null)
        addwatchlistButton.addEventListener("click", addToWatchlistButton);

    let remwatchlistButton = document.querySelector(".remWatchlist");
    if(remwatchlistButton != null)
        remwatchlistButton.addEventListener("click", remToWatchlistButton);

    addListenerPageReports();
    addListenerPageUsers();
    addListenerApproveReport();
    addListenerBlockDeleteUser();

    addAuctionCountdown();
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

function disableStopAuctionButton() {
    let id = this.getAttribute("data-id");
    sendAjaxRequest("put", "/api/auctions/" + id + "/stop", null, stopAuctionHandler);
}

function stopAuctionHandler() {
    let stop_button = document.querySelector("#stop_button");
    stop_button.remove();
}

function saveMethods() {
    let payMethodSelect = document.querySelector('#pay_method');
    let shipMethodSelect = document.querySelector('#ship_method');
    let pay_method = payMethodSelect.options[payMethodSelect.selectedIndex].value;
    let ship_method = shipMethodSelect.options[shipMethodSelect.selectedIndex].value;
    let data = { payM: pay_method, shipM: ship_method };

    console.log(pay_method);
    console.log(ship_method);
    //sendAjaxRequest("put", 'api/auctions/' + idk man + '/choose_methods', data, methodSelectionHandler);
}

function methodSelectionHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let close_button = document.querySelector('.moder-header button');
    close_button.click();
}

function addToWatchlistButton() {
    let id_auction = this.getAttribute("data-id");
    sendAjaxRequest("post", "/api/watchlists/" + id_auction, null, addToWatchlistHandler);
  }
  
function addToWatchlistHandler(){
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    console.log(this);
    let button = document.querySelector('.addWatchlist');
    button.classList.remove("addWatchlist");
    button.classList.add("remWatchlist");
    button.innerHTML = "Remove from Watchlist";
    button.removeEventListener("click", addToWatchlistButton);
    button.addEventListener("click", remToWatchlistButton);
}

function remToWatchlistButton() {
    let id_auction = this.getAttribute("data-id");
    sendAjaxRequest("delete", "/api/watchlists/" + id_auction, null, remToWatchlistHandler);
  }
  
function remToWatchlistHandler(){
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    console.log(this);
    let button = document.querySelector('.remWatchlist');
    button.classList.remove("remWatchlist");
    button.classList.add("addWatchlist");
    button.innerHTML = "Add to Watchlist";
    button.removeEventListener("click", remToWatchlistButton);
    button.addEventListener("click", addToWatchlistButton);
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
    url = "api/reports?page=" + page;
    sendAjaxRequest("get", url, null, pageReportsHandler);
}

function pageReportsHandler() {
    if (this.status != 200)
        console.log(this);
    let element = document.querySelector('.reports');
    element.innerHTML = this.responseText;
    document.querySelector('#reports').scrollIntoView();
    addListenerPageReports();
    addListenerApproveReport();
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
    url = "api/users?page=" + page;
    sendAjaxRequest("get", url, null, pageUsersHandler);
}

function pageUsersHandler() {
    if (this.status != 200)
        console.log(this);
    let element = document.querySelector('.users');
    element.innerHTML = this.responseText;
    document.querySelector('#users').scrollIntoView();
    addListenerPageUsers();
    addListenerBlockDeleteUser();
}

function addListenerApproveReport() {
    let accept = document.querySelectorAll(".accept_report");
    [].forEach.call(accept, function (button) {
        button.addEventListener("click", acceptReport);
    });

    let deny = document.querySelectorAll(".deny_report");
    [].forEach.call(deny, function (button) {
        button.addEventListener("click", denyReport);
    });
}

function acceptReport(event) {
    event.preventDefault();
    let id = this.getAttribute('data-id');
    url = "api/reports/" + id + "/" + 1;
    sendAjaxRequest("put", url, null, acceptReportHandler);
}

function acceptReportHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let id = JSON.parse(this.responseText);
    let status = document.querySelector('.report[data-id="' + id + '"] span');
    status.classList.remove('badge-warning');
    status.classList.add('badge-success');
    status.innerHTML = "Approved";
    let action = document.querySelector('.report[data-id="' + id + '"] td:last-child');
    action.innerHTML = "";
}

function denyReport(event) {
    event.preventDefault();
    let id = this.getAttribute('data-id');
    url = "api/reports/" + id + "/" + 2;
    sendAjaxRequest("put", url, null, denyReportHandler);
}

function denyReportHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    console.log(this.responseText);
    let id = JSON.parse(this.responseText);
    let status = document.querySelector('.report[data-id="' + id + '"] span');
    status.classList.remove('badge-warning');
    status.classList.add('badge-danger');
    status.innerHTML = "Denied";
    let action = document.querySelector('.report[data-id="' + id + '"] td:last-child');
    action.innerHTML = "";
}

function addListenerBlockDeleteUser() {
    let unblock = document.querySelectorAll(".unblock_button");
    [].forEach.call(unblock, function (button) {
        button.addEventListener("click", unblockUser);
    });

    let block = document.querySelectorAll(".block_button");
    [].forEach.call(block, function (button) {
        button.addEventListener("click", blockUser);
    });

    let delete_user = document.querySelectorAll(".delete_user_confirm");
    [].forEach.call(delete_user, function (button) {
        button.addEventListener("click", deleteUser);
    });
}

function unblockUser(event) {
    event.preventDefault();
    let id = this.getAttribute('data-id');
    url = "api/users/" + id + "/unblock";
    sendAjaxRequest("post", url, null, unblockUserHandler);
}

function unblockUserHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let id = JSON.parse(this.responseText);
    let button = document.querySelector('.unblock_button[data-id="' + id + '"]');
    button.className = "btn btn-warning block_button";
    button.innerHTML = "Block";
    button.removeEventListener("click", unblockUser);
    button.addEventListener("click", blockUser);
}

function blockUser(event) {
    event.preventDefault();
    let id = this.getAttribute('data-id');
    url = "api/users/" + id + "/block";
    sendAjaxRequest("post", url, null, blockUserHandler);
}

function blockUserHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let id = JSON.parse(this.responseText);
    let button = document.querySelector('.block_button[data-id="' + id + '"]');
    button.className = "btn btn-success unblock_button";
    button.innerHTML = "Unblock";
    button.removeEventListener("click", blockUser);
    button.addEventListener("click", unblockUser);
}

function deleteUser(event) {
    event.preventDefault();
    let id = this.getAttribute('data-id');
    url = "api/users/" + id;
    sendAjaxRequest("delete", url, null, deleteUserHandler);
}

function deleteUserHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let id = JSON.parse(this.responseText);
    let closeModal = document.querySelector('.delete_user_cancel[data-id="' + id + '"]');
    closeModal.click();
    // update pagination
    let page = document.querySelector('.user_list').getAttribute('data-id');
    let url = "api/users?page=" + page;
    sendAjaxRequest("get", url, null, pageUsersHandler);
}

function addAuctionCountdown() {
    let countdown = document.getElementById("countdown");
    if (countdown != null) {
        let countDownDate = new Date(countdown.getAttribute('data-id') + ' +0100').getTime();
        updateCountdown(countdown, countDownDate);

        setInterval(() => {
            updateCountdown(countdown, countDownDate);
        }, 1000);
    }
}

function updateCountdown(countdown, countDownDate) {
    // Get today's date and time
    let now = new Date().getTime();

    // Find the distance between now and the count down date
    let distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    let days = Math.floor(distance / (1000 * 60 * 60 * 24));
    let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    let seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the element with id="demo"
    if (days != 0)
        countdown.innerHTML = days + "d " + hours + "h "
            + minutes + "m " + seconds + "s ";
    else if (hours != 0)
        countdown.innerHTML = hours + "h "
            + minutes + "m " + seconds + "s ";
    else if (minutes != 0)
        countdown.innerHTML = minutes + "m " + seconds + "s ";
    else
        countdown.innerHTML = seconds + "s ";

    // If the count down is finished, write some text
    if (distance < 0) {
        location.reload();
    }
}

addEventListeners();
