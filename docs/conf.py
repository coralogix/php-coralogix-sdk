#!/usr/bin/env python3
# -*- coding: utf-8 -*-

project = 'Coralogix PHP SDK'
github_project_url = 'https://github.com/coralogix/php-coralogix-sdk'
copyright = '2018, Coralogix Ltd.'
author = 'Coralogix Ltd.'
version = '1.0.0'
release = '1.0.0'

extensions = [
    'sphinx.ext.autodoc',
    'sphinx.ext.intersphinx',
    'sphinxcontrib.phpdomain',
]

templates_path = ['_templates']
source_suffix = '.rst'
master_doc = 'index'
language = None
exclude_patterns = ['_build']
default_role = 'literal'
pygments_style = 'sphinx'
todo_include_todos = False

rst_prolog = """
.. warning::
   The Coralogix PHP SDK is deprecated and not longer supported.
   For PHP PHP 7.4+, please use the `PHP OpenTelemetry Instrumentation <https://coralogix.com/docs/php-opentelemetry-instrumentation/>`_ instead.
"""