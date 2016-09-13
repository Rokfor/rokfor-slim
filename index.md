---
layout: backend
title: Rokfor
permalink: /
---

## About

**Rokfor is a headless content management with JSON API running on regular LAMP stack
or in the cloud. The API is restful and supports both read and write actions.
Rokfor focuses on flexible structures and relations between data, somehow combining
SQL and NoSQL concepts.**

The core is based on [Slim Framework](http://slimframework.com) for PHP
and various other open source projects like [Propel](http://propelorm.org)
for the database abstraction and [AdminLTE](https://almsaeedstudio.com/preview)
for the backend templating.

Rokfor is installable with [Composer](https://getcomposer.org) and requires a 
MySQL Database to work properly.

## Screenshots


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
  
## Structure

[Rokfor](https://www.rokfor.ch) was used to generate printed matter. For that reason, 
the database is inspired by books and periodicals with a strong focus on
structural relations. Some of the features are:

<img src="/rokfor-screenshots/structure.svg" alt="Structure" class="infographic">

- Basic containers called *books*, divided into parts, called *chapters*.
- Books can be cloned into multiple instances called *issues*.
- Every *chapter* contains pages, called *contributions*.
- *Chapters* are recursively nestable.
- *Contributions* consist of fields, defined in *templates*.
- Field support various data types: Text, Text Arrays, RTF Text, Markdown, 
  Tables, Numbers, Dates, Locations, Images and File uploads, Tags, 
  Selectors, Sliders (x), Matrix Sliders (x-y).
- Data relations: between fields, between structures, fixed values
  or free collections.

## Features
  
- Read only api with a bearer-key authentification based on user
  rights.
- Read write api with JWT tokens.  
- Access rights per book, issue, template or chapter.
- Roles:  Superusers, Administrators and Users.
- Backend Features like searching, assigning publish dates and states
  to documents.
- Installable via composer, using grunt and bower as build system.