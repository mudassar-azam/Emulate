<style>
    /* Footer styling */
.footer {
  background-color: #000;
  color: #fff;
  padding: 20px 0;
  /*margin-top:20px;*/
  text-align: center;
}

.footer-content {
  max-width: 800px;
  margin: auto;
  padding: 10px;
}

.footer h3 {
  font-size: 24px;
  margin-bottom: 10px;
  color: #fff;
}

.footer p {
  font-size: 14px;
  margin-bottom: 20px;
}

.footer-links {
  list-style: none;
  padding: 0;
  margin-bottom: 20px;
}

.footer-links li {
  display: inline;
  margin: 0 10px;
}

.footer-links a {
  color: #fff;
  text-decoration: none;
  font-size: 14px;
}

.footer-links a:hover {
  text-decoration: underline;
}

.footer-social a {
  color: #fff;
  margin: 0 10px;
  font-size: 18px;
  text-decoration: none;
}

.footer-social a:hover {
  color: #fff;
}

.footer-bottom {
  font-size: 12px;
  margin-top: 10px;
}

</style>
<footer class="footer">
  <div class="footer-content">
    <h3>Emulate</h3>
    <p>Your go-to platform for innovative solutions.</p>

    <ul class="footer-links">
        <li><a href="{{route('products.index')}}">Products</a></li>
        <li><a href="{{route('buyer.celeb')}}">Creators</a></li>
        <li><a href="{{route('product.rent')}}">Rental</a></li>
        <li><a href="{{route('product.buy')}}">Purchase</a></li>
        <li><a href="#">About Us</a></li>
        <li><button style="background: none;color: white;border: none;" onclick="openPopup('signin')">Interested in selling?</button></li>
    </ul>

    <div class="footer-social">
      <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
      <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
      <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
      <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
    </div>
  </div>
  
  <div class="footer-bottom">
    <p>&copy; 2024 Emulate. All rights reserved.</p>
  </div>
</footer>
