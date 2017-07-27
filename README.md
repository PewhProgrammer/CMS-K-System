# CMS-K and K-Screens

SE Project

## Setting up the webserver
1. Install MAMP as webserver (http://downloads4.mamp.info/MAMP-PRO-WINDOWS/releases/3.3.1/MAMP_MAMP_PRO_3.3.1.exe)
2. Set python environment path in your system ('C:\MAMP\bin\python\bin\' if using MAMPs python)
3. Download pip (https://bootstrap.pypa.io/get-pip.py) and install it (python get-pip.py) (already installed if you're using Python 2 >=2.7.9 or Python 3 >=3.4)
4. Go to '\python\Scripts' and run 'pip install beautifulsoup4 python_dateutil urllib'
5. Install nodeJS (https://nodejs.org/dist/v6.11.1/node-v6.11.1-x64.msi)
6. Install grunt-cli (npm install -g grunt-cli)
7. Type "npm install" to download the dependencies
8. Type "grunt run" to trigger the build process
9. Set the newly created www-folder as root directory for your webserver
10. Enter localhost on Google Chrome

Remarks: nodeJS is only needed to create the www-folder. Once built you only need that one to upload to your Apache server.

## Technology Stack

* [jQuery]
* [Bootstrap]
* [Grunt]
* [PHP]
* [MySQL]
* [Python]

## Timeline


| Time                	| Date    	| Implementation                                                                                                               	| Important Deliverables                                                                                                                                                                              	|
|---------------------	|---------	|------------------------------------------------------------------------------------------------------------------------------	|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------	|
| Iteration 2, week 1 	| 9 June  	| - Refined User Interface (template) <br />- Setting up the Database                                                                	|                                                                                                                                                                                                     	|
| week 2              	| 16 June 	| - Selecting/Deleting resources from Database                                                                                 	|                                                                                                                                                                                                     	|
| week 3              	| 23 June 	| - Integrating all monitors into our system such that we can change their screening                                         	|                                                                                                                                                                                                     	|
| week 4              	| 30 June 	| - Implemented the functionality to change monitors during configuration page <br />- Filter monitor according to their Location 	| - GUI Paper prototypes for all use cases including exceptional scenarios <br />- UML Class and Sequence diagramms for all use cases <br />- A working prototype implementing most of the must-have requirements 	|
| Iteration 3, week 1 	| 7 July  	| - Implementing Timer Functionality <br />- Log-in screen                                                                           	|                                                                                                                                                                                                     	|
| week 2              	| 14 July 	| - Plug & Play                                                                                                                	|                                                                                                                                                                                                     	|
| week 3              	| 21 July 	| - Implemented Labels <br />- Debugging                                                                                             	|                                                                                                                                                                                                     	|
| week 4              	| 28 July 	| - Debugging <br />- Release                                                                                                        	| - Final Working Prototype presented to Client <br />- Final every document <br />- Implementation of all must-haves and (if time permits) may-haves                                                             	|

## Authors

* **Jonas Mohr** - *Ongoing work*
* **Esha chatterjee** - *Ongoing work*
* **Ba Thinh Tran** - *Ongoing work*
* **Marc Schubhan** - *Ongoing work*

See also the list of 
[contributors](https://repos.se.cispa.saarland/ezekiel_soremekun/projectp002-multimedia-infostream-kiosksystem/settings/members) 
who participated in this project.
