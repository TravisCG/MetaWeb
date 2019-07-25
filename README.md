# MetaWeb
Metagenomic webservice to automatically analyse sequences

Right now it is just a bunch of scripts, quick and dirty methods
to make the job done.

## Dependencies

* Kraken2
* Bracken
* Pavian
* FastQC
* PHP
* Apache2

Be careful every component has it's own dependencies!

## Directory structure

/home/services/qc: Place of FastQC
/home/services/metagenomics: Put the files from 'service' of this repository to here. Also install Kraken2, Bracken here. Database should be here too.
/var/www/html: Copy the files from 'web' of this repository to here.
/home/upload: Users upload files to here

## Crontab

I have put the following line into crontab:
00 0    * * *   root    bash /home/services/metagenomics/analyse.sh >>/home/services/metagenomics/log/stdout.txt 2>>/home/services/metagenomics/log/stderr.txt

## Working

Every midnight the analysis.sh from /home/services/metagenomics run. Copy the uploaded files to another place, run FastQC, Kraken2, Bracken and put results into
/var/www/html/metagenomics. Next day the users can see the results. There is no user interaction, because I do not want to train people and I do not have time to
make helpdesk. If there is no interaction, users cannot brake anything.

However there are some limitation. The script assume the user upload gzipped, paired-end files and the length is 2x 150.

There is a shiny server in port 3838 with Pavian. Right now users need to download the report files and upload here to visualize the results.
