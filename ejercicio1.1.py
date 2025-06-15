import time

test_results = []
def record_test(test_name, condition):
    emoji = "✅" if condition else "❌"
    test_results.append(f"{emoji} {test_name}")

def logarithmic_complexity(n):

    start = time.time()
    
    
    if not isinstance(n, int) or n < 1:
        end = time.time()
        elapsed = end - start
        return -1, elapsed
    
    
    value = 1
    count = 0
    while value <= n:
        value *= 2  
        count += 1  
    
    end = time.time()
    elapsed = end - start
    return count, elapsed

def test_o1_1():
    cnt, _ = logarithmic_complexity(1)
    record_test("o1.1.1 n=1 → count==1", cnt == 1)
    cnt, _ = logarithmic_complexity(10)
    record_test("o1.1.2 n=10 → count==4", cnt == 4)
    cnt, _ = logarithmic_complexity(100)
    record_test("o1.1.3 n=100 → count==7", cnt == 7)
    out = logarithmic_complexity(5)
    record_test(
        "o1.1.4 returns (int, float)",
        isinstance(out[0], int) and isinstance(out[1], float)
    )

    cnt_err, _ = logarithmic_complexity("a")
    record_test("o1.1.5 invalid input returns -1", cnt_err == -1)

test_o1_1()


print("=== RESULT ===")
for r in test_results:
    print(r)


print("\n=== EJEMPLOS ADICIONALES ===")
test_cases = [1, 5, 10, 16, 100, 1000]
for n in test_cases:
    count, time_elapsed = logarithmic_complexity(n)
    print(f"n={n:4d} → duplicaciones={count:2d}, tiempo={time_elapsed:.6f}s")


    