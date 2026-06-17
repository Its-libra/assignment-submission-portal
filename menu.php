    <style>
    .hero {
      position: relative; /* Position relative for the overlay */
      background: url('images/image10.jpg') no-repeat center center / cover;
      height: 100vh;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    .hero::before {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;

      z-index: 1; /* Ensure the overlay is above the background image */
    }

    .hero-content {
      position: relative; /* Position relative for the text */
      z-index: 2; /* Ensure the text is above the overlay */
      animation: fadeIn 0.6s ease-in-out;
    }

    .hero h1 {
      font-size: 3rem;
      font-weight: 700;
      color: #004d40; /* Dark Teal for contrast */
      text-shadow: 2px 2px 6px rgba(255, 255, 255, 0.8);
    }

    .hero p {
      font-size: 1.25rem;
      margin-top: 15px;
      color: #004d40; /* Dark Teal for contrast */
    }</style>
<?php include"header.php" ?>
<section class="hero">
  <div class="hero-content text-white">
    <h1>Welcome to the Assignment Submission Portal</h1>
    <p>Submit, review, and manage assignments online – fast and easy!</p>
  </div>
</section>
<?php include "footer.php" ?>
