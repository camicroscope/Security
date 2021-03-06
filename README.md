# caMicroscope Security and Router Container

This is intended for use with a docker deployment, or a deployment behind a reverse proxy. All requests should be directed through this service or container.

## Configuration

### SSL

To enable SSL, mount the private key and certificate files to ssl/privatekey.pem and ssl/certificate.pem respectively. HTTPS mode will only be enabled if both of these files are present.

### routes.json

Use routes.json to expose specific routes. If no match is found, it tries to use the provided root, if specified.
Under services, should be each top level service. Each service has a \_base for common elements of the urls (e.g. container name), \_public set to true to avoid key checks, and named resource objects, which in turn have methods. Methods either have the rest of the url, or a resolver (see "Resolvers")

Of course, the nomenclature chosen may not match configuration, but the important thing to note is that requests, outside of those directed at the root service, should be in the form https://<url base>/service/resource/method.

### User Management

This tool does not directly keep track of users, but it provides a framework to integrate with a service which does.
In routes.json, add an "auth" section with the following configuration options.


permissions_field - the field in the given jwt to check for permission attributes; expects a list.

(more configuration may be added soon)

#### attributes
A specific route can be assigned an attribute regarding its access ("attr"). If an attr is present on a route, it's routed if and only if the user check for that attr returns okay.


#### Query Field Checks

check_param in a route's config will check if the content of that paramater in the query exists and is in a list in the user's key field

### environment variables

As of now, two settings may be changed with environment variables:

SECRET - the secret for JWT checks
DISABLE_SEC - set to true to skip all auth checks regardless of if public is set. Designed for cert/testing.

### Resolvers
Resolvers are set by setting the "method" level to "\_resolver"-- the actual input to the method is then stored as {IN}

destination - what to use as the method url, after {OUT} substitution,
url - the url to check
field - the field in the response to assign to {OUT}
before - a string or list of strings to get the variable before; if multiple match, the first match is used
after - a string or list of strings to get the variable after; if multiple match, the first match is used
