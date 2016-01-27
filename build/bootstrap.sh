#!/bin/bash

MYDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

cp -f "${MYDIR}/pre-commit" "${MYDIR}/../.git/hooks/pre-commit"
cp -f "${MYDIR}/post-commit" "${MYDIR}/../.git/hooks/post-commit"

chmod +x $MYDIR/../.git/hooks/*