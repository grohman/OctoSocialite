# OctoSocialite
october cms socialite plugin

#This package requires RainLab.User

#Installation
1)
1.1) git clone https://github.com/grohman/OctoSocialite.git plugins/grohman/socialite

or

1.2) git submodule add https://github.com/grohman/OctoSocialite plugins/grohman/socialite

2) mkdir -p config/grohman/socialite

3) cp plugins/grohman/socialite/config/config.php config/grohman/socialite

4) cd plugins/grohman/socialite

5) composer install

# Install more providers
1) Find provider at https://socialiteproviders.github.io

2) Go to project root and run composer require socialiteproviders/$providerName

3) Update config/grohman/socialite/config.php with new provider info

4) Go to /backend/grohman/socialite/providers in browser and add provider data
