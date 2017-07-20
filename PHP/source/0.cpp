#include <iostream>
#include <cstdio>
#include <iomanip>
using namespace std;
const int N = 51;
int n, m;
double p, a[N];
double f[N][N];
int trace[N][N], ans[N];
double power(const double a, const int b)
{
    if (b == 1) return a;
    double tmp = power(a, b >> 1);
    if (b % 2) return tmp * tmp * a;
    else
        return tmp * tmp;
}
double cal(const int sl)
{
    double faile = power(1.0 - p, sl);
    return (1.0 - faile);
}
bool Less(double a, double b) {
    return a - b < 0;
}
int main()
{
    //freopen("input.inp", "r", stdin);
    //freopen("out1.out", "w", stdout);
    //freopen("aircraft.inp", "r",  stdin);
    //freopen("aircraft.out", "w", stdout);
    ios_base :: sync_with_stdio(false); cin.tie(0);
    cin >> n >> m >> p;
    for (int i = 1; i <= n; i++) cin >> a[i];
    for (int i = 1; i <= m; i++) f[1][i] = cal(i) * a[1];
    for (int i = 1; i <= n; i++) f[i][0] = -1;
    for (int i = 2; i <= n; i++)
        for (int j = i; j <= m; j++)
            for (int l = i - 1; l < j; l++)
            {
                int slnow = j - l;
                double trung = cal(slnow);
                if (f[i][j] < f[i - 1][l] + a[i] * trung)
                {
                    f[i][j] = f[i - 1][l] + a[i] * trung;
                    trace[i][j] = l;
                }
            }
    int slnow = m, ii = n;
    while (ii) {
        ans[ii] = slnow - trace[ii][slnow];
        slnow -= ans[ii--];
    }
    for (int i = 1; i <= n; i++) cout << ans[i] << " ";
    return 0;
}
