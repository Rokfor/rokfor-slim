---
layout: backend
title: Api
permalink: /api/
markdown: kramdown
---

**This page covers only a limited selection of `GET` api calls. Please refer to 
the [apiary documentation](http://docs.rokfor.apiary.io) for a detailed description
of the api.**

## Read Only API

### Access Key

Why is there a key at all?

You need to set a read only key to access data via `GET` calls. This can be done
in the user profile. With a read only key, the same data is exposed as a user can
read within the backend. That's why it is useful to have a read only key, even though
it might be published. For example, you can add a specific api user who has only a 
limited range of readable chapters and issues.

Sending the key is done via a bearer authentification header or a access_token
query string. Sending a header is probably a better solution since the query
string won't be too cluttered and the api key probably does not show up in the
server log.

    GET /api/contributions/1/1?access_token=[key]
    
    $ curl -H "Authorization: Bearer [key]" http://localhost:8080/api/contributions/1/1

It is always a good idea to serve the api on a ssl secured webserver.

### Current API Routes

#### Loading a collection of contributions

    GET /api/contributions/:issueid|:issueid-:issueid.../:chapterid|:chapterid-:chapterid...?[options]
    
    Options:
    
    - query=string                                                (default: empty)
    - filter=[id|date|sort|templateid[s]]:[lt[e]|gt[e]|eq|like]   (default: [omitted]:like)
    - sort=[[id|date|name|sort]|chapter|issue|templateid[s]]:[asc|desc]           (default: sort:asc)
    - limit=int                                                   (default: empty)
    - offset=int                                                  (default: empty)
    - data=[Fieldname|Fieldname|XX]                               (default: empty)
    - populate=true|false                                         (default: false)
    - verbose=true|false                                          (default: false)
    - template=id                                                 (default: empty)
    - status=draft|published|both                                 (default: published)


- Query: search for a string within the contribution name or the text fields
Special queries: date:now is transformed into the current time stamp
- Filter: Applies the search string passed in query to certain fields, to the creation
date, the contribution id or sort number.
By default (if fields are omitted) the search query is applied to the name of the 
contribution and its content fields (full text search).
Furthermore, the comparison can be defined with equal, less than, greater than
or like (eq,lt,lte,gt,gte,like). Less and greater than does automatically cast
a string to a number.
- Sort: Sort the results by id, date, name or manual sort number (sort) either 
ascending or descending. It is also possible to sort by a custom id of a template field.
Contributions can also be sorted by chapter or issue.
Please note: You need to choose between id, date, name and sort. You can add one
custom sort field and the chapter and issue flag. i.E:
sort=date|chapter|issue|23 would sort by date, chapter, issue and the custom field 23.
- Limit and Offset: Create pages with a length of [limit] elements starting at
[offset].
- Data: Add additional field infos to the result set of a contributions.
For example, you need the title field of a contribution already in the
result set to create a multilingual menu. Or you need all images for a
slideshow over multiple contributions.
- Populate: Sends all data (true). Equals data=All\|Available\|Fields
- Verbose: Send complete Information about a dataset. In most cases, this 
is too much and just slowing down the connection.
- Template: limit to a certain template id
- Status: Including draft contributions, published contributions or both. Open
Contributions are never shown.


Examples:

    GET /api/contributions/1/14-5?query=New+York

Searches for all contributions within issue 1 and chapters 14 and 5 for the String "New York".

    GET /api/contributions/1/14-5?query=New+York&amp;filter=1|6:eq

Searches for all contributions within issue 1 and chapters 14 and 5 for the exact String "New York" within both fields with the template id 1 and 6.

    GET /api/contributions/1/14-5?query=12&amp;filter=sort:gtlimit=1

Searches for all contributions within issue 1 and chapters 14 and 5 with a sort value &gt; 12 and a limitation to 1 item. This represents the next contribution in a manually sorted list, since the list is has a default sort order by 'sort, asc'.

    GET /api/contributions/1/14-5?query=12&amp;filter=sort:lt&amp;sort=sort:desc&amp;limit=1

Searches for all contributions within issue 1 and chapters 14 and 5 with a sort value &lt; 12 and a limitation to 1 item, order descending. This represents the previous contribution in a manually sorted list.

    GET /api/contributions/12/19?limit=10&amp;offset=20

Returns 10 contributions of issue 12 and chapter 19 starting after contribution 20.

    GET /api/contributions/5-6-7/1-2-3?sort=date:desc&amp;data=Title|Subtitle

Returns all contributions of issue 5, 6 and 7 and chapter 1, 2 and 3 ordered by date, descending. Additionally, populates each contribution entry with the content of the fields Title and Subtitle.

    GET /api/contributions/1/1?populate=true&amp;verbose=true

Returns all contributions of chapter 1 and issue 1. Adds all fields to each contribution and additionally prints a lot of information to each field and contribution.

    GET /api/contributions/1/1?template=12

Returns all contributions of chapter 1 and issue 1 based on the template 12

#### Loading a single contribution

    GET /api/contribution/:id?[options]
    
    Options:
    
    - verbose=true|false                   (default: false)

- Verbose: Send complete Information about a dataset. In most cases, this 
is too much and just slowing down the connection.

Examples:

    GET /api/contributions/12?verbose=true

Loads all available data from contribution with the id 12

#### Structural Queries

    GET /api/books|issues|chapters/[:id]?[options]
    
    Options:
    
    - data=[Fieldname|Fieldname|XX]        (default: empty)
    - populate=true|false                  (default: false)
    - verbose=true|false                   (default: false)

- Data: Add additional field infos to the result set of a contributions.
For example, you need the title field of a contribution already in the
result set to create a multilingual menu. Or you need all images for a
slideshow over multiple contributions.
- Populate: Sends all data (true). Equals data=All\|Available\|Fields
- Verbose: Send complete Information about a dataset. In most cases, this 
is too much and just slowing down the connection.

Examples:

    GET /api/books

Shows all books available for the current api key

    GET /api/chapters/3

Shows all information about chapter 3

    GET /api/issue/2?verbose=true&amp;populate=true

Shows all information about issue 2. Additionally, raises the verbosity level and populates all data fields if a issue has backreferences to contributions.