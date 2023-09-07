  <div>
    <a href="#popup" class="chat-toggle">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="chat-icon">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
      </svg>
    </a>
  </div>

  <div class="popup" id="popup">
    <div class="popup-content">
      <div class="popup-header">
        <h3 class="heading-tertiary">Message Us</h3>
        <a href="#" id="popup-close-btn">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" icon popup-close-icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </a>
      </div>
      <div class="popup-main">
        <form id="message-form" class="customer-form">
          <div>
            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject">
            <p id="subj-err" class="error-msg margin-bottom-sm color-red" style="margin-top: 5px;"></p>
          </div>
          <div>
            <label for="message">Your message</label>
            <textarea rows="10" cols="30" id="message" name="message"></textarea>
            <p id="msg-err" class="error-msg margin-bottom-sm color-red" style="margin-top: 5px;"></p>
          </div>
          <button id="submitBtn" class="btn-form btn-small make-btn-full">Submit</button>
        </form>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const backdrop = document.getElementById('popup');
      const closeBtn = document.getElementById('popup-close-btn');
      backdrop.addEventListener('click', function(e) {
        if (e.target.matches('#popup')) {
          closeBtn.click();
        }
      });
      const submitBtn = document.getElementById('submitBtn');
      submitBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const messageForm = document.getElementById('message-form');
        const formData = new FormData(messageForm);
        const subject = formData.get('subject');
        const message = formData.get('message');
        const subjectErr = document.getElementById('subj-err');
        const messageErr = document.getElementById('msg-err');
        let valid = 1;
        if (subject === "" || subject.length == 0) {
          valid = 0;
          subjectErr.innerText = "Please enter subject.";
        } else {
          subjectErr.innerText = "";
        }
        if (message === "" || message.length == 0) {
          valid = 0;
          messageErr.innerText = "Please enter your message.";
        } else {
          messageErr.innerText = "";
        }
        if (valid === 1) {
          let xhr = new XMLHttpRequest();
          xhr.open('POST', 'handle_message_ajax.php');
          xhr.send(formData);
          xhr.onload = function() {
            if (this.status == 200 && this.readyState == 4 && this.responseText === "success") {
              alert("Your message has been successfully sent.");
              messageForm.reset();
              closeBtn.click();
            } else {
              alert("There was an error sending message.");
            }
          };
          xhr.onerror = function() {
            console.log('Request error');
          };
        }
      });
    });
  </script>
