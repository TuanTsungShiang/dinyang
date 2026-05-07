<!-- Laravel: InquiryController + LINE Message API / LINE Notify 替代方案 -->
<section class="contact-section" id="contact">
  <div class="container contact-grid">
    <div>
      <div class="section-title" style="text-align: left; margin-left: 0">
        <h2>聯絡我們 / 詢價表單</h2>
        <p style="margin-left: 0">
          歡迎填寫以下表單，告訴我們您的需求，我們將盡快與您聯繫。
        </p>
      </div>
      <form
        class="form-panel"
        action="/inquiries"
        method="post"
        enctype="multipart/form-data"
      >
        @csrf
        <div class="form-grid">
          <div class="field">
            <label for="company">公司名稱 *</label>
            <input
              id="company"
              name="company_name"
              type="text"
              placeholder="請輸入公司名稱"
              required
            />
          </div>
          <div class="field">
            <label for="name">聯絡人 *</label>
            <input
              id="name"
              name="contact_name"
              type="text"
              placeholder="請輸入聯絡人姓名"
              required
            />
          </div>
          <div class="field">
            <label for="phone">電話 *</label>
            <input
              id="phone"
              name="phone"
              type="tel"
              placeholder="請輸入聯絡電話"
              required
            />
          </div>
          <div class="field">
            <label for="email">Email *</label>
            <input
              id="email"
              name="email"
              type="email"
              placeholder="請輸入 Email"
              required
            />
          </div>
          <div class="field full">
            <label for="message">需求說明 *</label>
            <textarea
              id="message"
              name="message"
              placeholder="請詳細描述您的產品需求、規格、數量與應用環境…"
              required
            ></textarea>
          </div>
          <div class="field full">
            <label for="attachment">檔案上傳</label>
            <div class="upload-box">
              <input
                id="attachment"
                name="attachment"
                type="file"
                accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx"
              />
              <div>
                支援 PDF、JPG、PNG、Word、Excel，單檔建議 10MB 以內。
              </div>
            </div>
          </div>
        </div>
        <div class="form-footer">
          <label class="privacy"
            ><input type="checkbox" required /> 我已閱讀並同意
            <a href="#">隱私權政策</a></label
          >
          <button class="btn btn-blue" type="submit">送出詢價</button>
        </div>
      </form>
    </div>
    <aside class="line-card">
      <h3>加入 LINE<br />快速洽詢</h3>
      <p>掃描 QR Code 加入好友<br />專人為您服務！</p>
      <div class="qr">
        <img
          src="/img/line_qrcode_for_dev_001.png"
          alt="掃描 QR Code 加入 LINE"
          width="210"
          height="210"
        />
      </div>
      <a
        class="btn btn-line"
        href="https://line.me/R/ti/p/@@503xumnz"
        target="_blank"
        rel="noopener"
      >
        <img src="/img/icon/line_bubble.png" alt="" />
        立即加入 LINE
      </a>
    </aside>
  </div>
</section>
