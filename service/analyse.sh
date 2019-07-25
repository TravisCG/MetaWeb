#!/bin/bash
# Copy data from the upload directory to the analysis dir

UPLOAD=/home/upload                                        # Read the sequences from here
INPUTDATA=/home/services/metagenomics/inputdata            # Process sequences from here
OUTPUT=/var/www/html/metagenomics                          # Results directory
FASTQC=/home/services/qc/FastQC/fastqc                     # FASTQC directory
KRAKEN=/home/services/metagenomics/kraken2/kraken2         # Kraken2
BRAKEN=/home/services/metagenomics/Bracken/bracken         # Bracken

for NAME in $UPLOAD/*_R1_*
do
	FQ1=`basename $NAME`
	FQ2=${FQ1/_R1_/_R2_}

	mv $NAME $UPLOAD/$FQ2 $INPUTDATA
	$FASTQC -o $OUTPUT $INPUTDATA/$FQ1 $INPUTDATA/$FQ2
	rm $OUTPUT/*.zip
	$KRAKEN --db /home/services/metagenomics/db/16s_50k --minimum-base-quality 20 --confidence --paired --gzip-compressed --threads 4 --use-names --output /dev/null --report $OUTPUT/${FQ1%fastq.gz}report $INPUTDATA/$FQ1 $INPUTDATA/$FQ2
	$BRAKEN -d /home/services/metagenomics/db/16s_50k -i $OUTPUT/${FQ1%fastq.gz}report -o $OUTPUT/${FQ1%fastq.gz}abundance -r 300 -l G -t 5
	rm $INPUTDATA/$FQ1 $INPUTDATA/$FQ2
done
