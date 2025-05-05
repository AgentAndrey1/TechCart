<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f1f1f1;
      margin: 0;
      padding: 0;
    }
    .header {
      background-color: #1a675e;
      color: white;
      padding: 20px;
      font-size: 25px;
      display: flex;
      align-items: center;
    }
    .header .back {
      margin-right: 15px;
      font-size: 24px;
      cursor: pointer;
    }
    .profile-section {
      display: flex;
      align-items: center;
      padding: 30px;
      border-bottom: 1px solid #ccc;
    }
    .profile-section img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background-color: #ddd;
      margin-right: 20px;
    }
    .profile-details {
      display: flex;
      flex-direction: column;
    }
    .profile-details strong {
      font-size: 18px;
      color: #1a4d4a;
    }
    .profile-details span {
      color: gray;
    }
    .info-section {
      padding: 20px;
    }
    .info-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    .info-header h2 {
      color: #1a4d4a;
    }
    .edit-btn {
      padding: 5px 10px;
      background-color: #ccc;
      border: none;
      cursor: pointer;
    }
    .info-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
    }
    .info-item {
      font-size: 14px;
    }
    .info-item p {
      margin: 4px 0;
    }
    .info-label {
      color: gray;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="header">
    <div class="back">&larr;</div>
    My Profile
  </div>

  <div class="profile-section">
  <div class="user-icon">
  <img src="img/codicon_account.svg">
      <strong>John Doe</strong>
    </div>
  </div>

  <div class="info-section">
    <div class="info-header">
      <h2>Profile Information</h2>
      <button class="edit-btn">Edit</button>
    </div>
    <div class="info-grid">
      <div class="info-item">
        <p class="info-label">Name</p>
        <p>Jaycee</p>
      </div>
      <div class="info-item">
        <p class="info-label">Username</p>
        <p>antoniojaycee</p>
      </div>
      <div class="info-item">
        <p class="info-label">Email Address</p>
        <p>johndoe01@email.com</p>
      </div>
      <div class="info-item">
        <p class="info-label">Phone Number</p>
        <p>(+63) 901 2345 678</p>
      </div>
      <div class="info-item">
        <p class="info-label">Date of Birth</p>
        <p>05-01-1999</p>
      </div>
      <div class="info-item">
        <p class="info-label">Store Name</p>
        <p>Kabadingan Store</p>
      </div>
    </div>
  </div>
</div>

</body>
</html>
