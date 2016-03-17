### Note: the prefix 'package::', corresponds to a puppet convention:
###
###       https://github.com/jeff1evesque/machine-learning/issues/2349
###
class package::six {
    include python

    package { 'six':
        ensure   => 'installed',
        provider => 'pip',
    }
}