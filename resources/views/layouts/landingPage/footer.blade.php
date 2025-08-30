<footer>
    <div class="container">
        <div class="footer-content">
            <!-- About Section -->
            <div class="footer-section">
                <h3>Famlic</h3>
                <p>A trusted crowdfunding platform, built for easy online fundraising and support when families and
                    students need help.</p>
            </div>

            <!-- Quick Links -->
            <div class="footer-section">
                <h3>Quick Links</h3>
                <p><a href="{{ route('homepage') }}">Home</a></p>
                <p><a href="{{ route('aboutUs') }}">About Us</a></p>
                <p><a href="{{ route('contactUs') }}">Contact</a></p>
                <p><a href="{{ route('privacyPolicy') }}">Privacy Policy</a></p>
            </div>

            <!-- Support -->
            <div class="footer-section">
                <h3>Support</h3>
                <p><a href="https://famlic.tawk.help/" target="_blank" rel="noopener noreferrer">Help Center</a></p>
                <p><a href="{{ route('login') }}">Raise Funds</a></p>
                <p><a href="{{ route('terms') }}">How it Works</a></p>
                <p><a href="{{ route('terms') }}">Safety Policy</a></p>
            </div>

            <!-- Connect -->
            <div class="footer-section">
                <h3>Connect</h3>
                <p>Email: <a href="mailto:support@famlic.ng">support@famlic.com</a></p>
                {{-- <p>Phone: +234 (0) 800 FAMLIC</p> --}}
                <p>Product of Freebyz Technologies Ltd</p>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="footer-bottom">
            <p>&copy; 2025 Famlic by Freebyz Technologies Ltd. All rights reserved.</p>
        </div>
    </div>
</footer>
