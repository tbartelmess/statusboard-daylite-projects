Daylite Projects on Status Board by Panic
============================

![Daylite Projects on Status Board - Example 1](http://files.web-entity.cz/daylite-statusboard-example1.jpg)

![Daylite Projects on Status Board - Example 2](http://files.web-entity.cz/daylite-statusboard-example3.png)

![Daylite Projects on Status Board - Example 3](http://files.web-entity.cz/daylite-statusboard-example2.jpg)

## Requirements
-----
- Webhosting with Apache and PHP 5.3+
- Daylite 4 :-)
- Status Board from Panic :-)

## Install
-----

1. Upload dayliteProjects.json and dayliteProjects.php
2. Edit dayliteProjects.php
3. Edit dayliteProjects.scpt file 
4. Load and start LaunchAgent for automatic updates
5. Add table widget to Status Board app


### 1. Upload files
Upload to your webhosting `dayliteProjects.json` (with example data) and `dayliteProjects.php` and make `dayliteProjects.json` writable.
 
### 2. Edit dayliteProjects.php
In `dayliteProjects.php` you can:

- Show/hide and change order of columns - priority, project name, stage, due date, category, owner, client and company. 
- Set width and text color for columns.
- Setup filter by categories.
- Setup filter by owners.
- Setup filter by clients.
- Set to order projects by priorty.
- Setup date format (!).
- Show for example "2 day(s)" instead of full date for due date (need correct date format).
- Possibility to show project bars.
- And setup nicknames for project owners :-)

### 3. Edit dayliteProjects.scpt

Change `www.domain.com` to path of your uploaded file `dayliteProjects.php`.
 	
	req := ASIHTTPRequest requestWithURL:(NSURL URLWithString:'http://www.domain.com/dayliteProjects.php?load').

### 4. Load and start LaunchAgent
Edit `com.webentity.sbdayliteprojects.plist` at line #10 to path of your copy of `dayliteProjects.scpt` file.

	<string>/path/to/dayliteProjects.scpt</string>

Move `com.webentity.sbdayliteprojects.plist` to `~/Library/LaunchAgents/`. Then run in terminal:

	launchctl load ~/Library/LaunchAgents/com.webentity.sbdayliteprojects.plist
	launchctl start com.webentity.sbdayliteprojects

### 5. Add table widget to Status Board app
Add a new table widget in Status Board with URL to your `dayliteProjects.php` on web hosting.

## Security
Add `.htaccess` and `.htpasswd` to same folder, where you have `dayliteProjects.php`

### .htaccess example

	Options Indexes
	AuthUserFile /full/path/to/folder/.htpasswd
	AuthGroupFile /dev/null
	AuthName "Please enter your ID and password"
	AuthType Basic
	require valid-user
	order deny,allow

### .htpasswd example (Petr:test)
	
	Petr:26wug3Q/Rsv7s
	
Add this two line before `req buildRequestHeaders.` in `dayliteProjects.scpt`
	
	req setUsername:'Petr'.
	req setPassword:'test'.

## Thanks to

- Marketcircle Inc. and AJ from Daylite forum
- Panic Inc.

## Support

Please note, it's the first beta release. I hope it's going to work for all of you.

Run into an issue? Throw an issue up on GitHub. Better yet, throw up a pull request with a fix. Thanks!

## ToDo list

- Use PHP $_GET variables to config filters and others.

## Author

[Petr Havelka](mailto:petr.havelka@web-entity.cz) - [@citronak](https://twitter.com/citronak)

## License

This widget is available under the MIT license:

	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in
	all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.