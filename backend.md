---
layout: backend
title: Usage
permalink: /usage/
markdown: kramdown
---


## Usage

### Log in

- Log into the backend as superuser `root` with the password `123` under the URL `/rf`.
- Change your password first: Edit your profile on the upper right side, change
  your username and password.
  
### Add some Structure

- Open the Settings <i class="fa fa-gears"></i>
- Click on _Folder Structure_
- Add a _book_, an _issue_ and a _chapter_

### Add a Template

- Open the Settings <i class="fa fa-gears"></i>
- Click on _Templates_
- Create a template
- Assing the newly created template to your book and chapter
- Add some fields to the template. Start with a text field, for example

### Add some Data

- Open your Book in the sidebar on your left
- Click on _New document_, type a name and choose the template
- Do something! Your actions are stored while typing
- Close without fear: Your content is be stored already

### Add Users and Roles

- Open the settings as superuser, click on _Users_
- Add a user by clicking on <i class="fa fa-plus"></i> _New User_
- Add a group by clicking on <i class="fa fa-plus"></i> _New Group_
- You can add users to your group, or you can assign groups to
  the user. You can assign books, issues, chapters and templates
  to groups
  
### API Keys

- To access the data, you need an API key
- Every user can generate his keys in the profile settings
- The access rights are the same both for API or backend access
- The api should only be exposed over SSL (https)
- Never expose your read/write key to the public. If you want to implement
  a public write function, for example to store comments, write a proxy script
  that does the authentification and calls the cms backend



