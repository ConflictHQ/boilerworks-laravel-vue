# Security Policy

## Reporting a Vulnerability

If you discover a security vulnerability in Boilerworks, please report it responsibly.

**Do not open a public issue.**

Instead, email **security@weareconflict.com** with:

- Description of the vulnerability
- Steps to reproduce
- Potential impact
- Suggested fix (if any)

We will acknowledge your report within 48 hours and aim to release a fix within 7 days for critical issues.

## Supported Versions

| Version | Supported |
| ------- | --------- |
| latest  | Yes       |

## Security Best Practices

When deploying Boilerworks:

- Set `APP_ENV=production` and `APP_DEBUG=false`
- Generate a fresh `APP_KEY` (`php artisan key:generate`) — never reuse the template's key
- Change all default credentials: Postgres (`DB_PASSWORD`), Redis (`REDIS_PASSWORD`), MinIO (`AWS_ACCESS_KEY_ID`/`AWS_SECRET_ACCESS_KEY`)
- Remove or re-password the seeded users (`admin@boilerworks.dev`, etc.) before exposing the app
- Use HTTPS in production and set `SESSION_SECURE_COOKIE=true`
- Review the security hardening in `bootstrap.md`
