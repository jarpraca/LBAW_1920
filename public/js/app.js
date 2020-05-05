function addEventListeners() {
  let form = document.querySelector(".editAuction");
  if(form != null) {
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
  stopButton.addEventListener("click", disableStopAuctionButton);
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

function disableStopAuctionButton() {
  let id = this.getAttribute("data-id");
  console.log("1-lucas");
  sendAjaxRequest("put", "/auctions/" + id + "/stop", null, stopAuctionHandler);
}

function stopAuctionHandler(){
  console.log("2-lucas");
  let stop_button = document.querySelector("#stop_button");
  stop_button.remove();
}

function imageDeletedHandler() {
  if (this.status != 200) 
    console.log(this);
  let item = JSON.parse(this.responseText);
  let element = document.querySelector('a[data-id="' + item.id + '"]');
  element.remove();
}

addEventListeners();
