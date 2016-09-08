---
layout: backend
title: Rokfor
permalink: /
---

<h2>About</h2>
<p>
  Rokfor is a headless, api-only content management. The API talks JSON. 
  The core is based on <a href="http://slimframework.com/">Slim Framework</a> for PHP
  and various other open source projects like <a href="http://propelorm.org/">Propel</a>
  for the database abstraction and <a href="https://almsaeedstudio.com/preview">AdminLTE</a>
  for the backend templating.
</p>
<p>
  Rokfor is installable with <a href="https://getcomposer.org">Composer</a> and requires a 
  MySQL Database to work properly.
</p>
<p>
  <table>
    <tr>
      <td class="noborder"  colspan="2">
        <img src="/rokfor-screenshots/rf-dashboard.png" alt="Dashboard">
      </td>
    </tr>
    <tr>
      <td class="noborder">
        <img src="/rokfor-screenshots/rf-contributions.png" alt="Contributions">
      </td>
      <td class="noborder">
        <img src="/rokfor-screenshots/rf-structure.png" alt="Structure">
      </td>
    </tr>
    <tr>
      <td class="noborder">
        <img src="/rokfor-screenshots/rf-templates.png" alt="Templates">
      </td>
      <td class="noborder">
        <img src="/rokfor-screenshots/rf-users.png" alt="Users">
      </td>
    </tr>          
  </table>            
</p>

<p>
  <ul>
  <li>  Flexible structures called "Books", divided into parts, called "Chapters".</li>
  <li>  Every book can have multiple instances called "Issues".</li>
  <li>  Every Chapter contains data, called "Contributions".</li>
  <li>  "Contributions" are collections of fields, gathered in templates.</li>
  <li>  Various data types supported: Text, Text Arrays, RTF Text, Tables, Numbers,
  Dates, Locations, Image and File uploads, Tags, Selectors, Sliders, Two Way
  Sliders.</li>
  <li>  Various data relations: field to fields, field to structures, fixed values
  and many more.</li>
  <li>  Read only api with a simple bearer-key authentification based on user
  rights.</li>
  <li>  Fine grained roles and rights system.</li>
  <li>  Installable via composer, using grunt and bower as build system.</li>
  </ul>
</p>

<p>
  Rokfor has already a longer history. The <a href="https://github.com/Rokfor/rokfor-cms">old build</a> 
  was mainly used to create printed matter. In order to make it more useful for the public, we 
  decided to rewrite it completely applying a modern way of writing php applications:
</p>



