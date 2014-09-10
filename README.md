

## Files explained

**Movies_script.php** - PHP script that parses http://www.imdb.com/chart/top and saves the top 10 in the database.

**Index.php** - is an example web page that demonstrates the searching of the top 10 by date.

**Medoo.min.php** - Database object for interacting with the database: http://medoo.in/

**MovieObject.php** - Movies object with accessors and mutators. 

## Usage

1. Download master zip-file.
2. Extract files to a folder
3. Copy the table structure from movies.sql to build the database.
4. Edit medoo.min.php to use the proper database connection.
5. Load the web page index.php on a php enabled server, this will run the movies_script.php and insert the data from imdb into the database.
6. Once index.php is loaded, you can perform a search based on the date that the data was inserted.
7. **Example usage**: If the data was inserted September 10 2014, then you can search by date using any format for example: 

```september 10 2014```

```2014 10 09```

```09 10 2014```

All of these searches will query the database for a proper match.

Enjoy.


