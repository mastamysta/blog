<h1>blog.php</h1>
<h2>Background</h2>
<p>
  The aim of this project is to produce a small personal log website to be hosted on my personal domain: 'no longer hosted'
  The site is a blog which allows me to sign in (as the sole user) and quickly post small chunks of prose (an hopefully images).
</p>
<h2>Code</h2>
<p>
  The bulk of the code is written in PHP. THe persistence layer is built using a MySQL database which I can manually manage using phpMyAdmin. Obviously the views are written in HTML5 and CSS using Bootstrap to keep things simple, however this is in a php wrapper to prevent access to protected data.
</p>
<h2>Reflection</h2>
<p>
  The main goal of this project was to pick up the basics of PHP so some sections are rough around the edges but I felt that I did a pretty good job of keeping the code readable and modular. For a more extensible network of applications all relying on one set of login details I might port the login and session handling system to a separate API.
  Given that this website uses session handling and a crypto login system, large parts of it are more or less a direct port of my webAPI project in Node.js. It probably goes without saying that in use cases such as this one, it's always best to use a professional credential API rather than trying to build one myself so this is more of an exercise in learning than actual security.
  In future I would like to add support for images to this platform, aswell as an email verification system so that I can open up the servers to multiple users. (Resulting in basically just another twitter clone)
</p>
