#!/usr/bin/env bash

sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start codex:*