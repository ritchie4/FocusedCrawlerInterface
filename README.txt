README for Tree-Edit Distance based IDEAL Extended Web-Crawler
================================================================================

================================================================================
Required Installations
================================================================================

Install the following in the listed order

Python 2.7
Scipy
Numpy
pyYAML
scikit
nltk
Geonamescache
pycountry
pyner

================================================================================
Usage (Back-End)
================================================================================

-python FocusedCrawler.py <type> <name> <pagelimit>

<type> = The type of crawler to use (input one of the following numbers)
         0 for the Focused Crawler
	 1 for the Event-Focused Crawler

<name> = The name of text file containing Input URLs 
	 (Usually will be addurls.txt).

<pagelimit> = The maximum number of pages to search for.

(Example: -python FocusedCrawler.py 1 addurls.txt 10)

================================================================================
Usage (Front-End)
================================================================================

--------------------------------------------------------------------------------
Setup
--------------------------------------------------------------------------------

Fill in one of any of the following following text fields:
	-Event Type
	-City
	-State
	-Country
	-Date
	-Month
	-Year

Pick a crawler type:
	-EventFC (Event-Focused Crawler)
	-FC (Focused-Crawler)

Choose a search page limit

Input a Seed Site URL
	-To add more URL fields, press +URL Entry

--------------------------------------------------------------------------------
Results
--------------------------------------------------------------------------------

Entered URLs: This is the list of Seed Site URLs inputted during Setup.

Found unique relevant URLs: List of URLs that were found by the crawler
	If EventFC is used: View Tree button shows the tree hierarchy of the 
	webpage involving name, location, and date.

For multiple submissions: The most recent submission will be displayed at the
top, older submissions will be below.