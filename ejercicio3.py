import matplotlib.pyplot as plt
import matplotlib.image as mpimg
import mplcursors  
from timeit import default_timer as timer

n_values = (100, 400, 600, 800, 1000, 1100)  
times = [] 

for n in n_values:
    start = timer()
    
    for i in range(n):
        for j in range(n):
            pass  
    
    end = timer()
    proc_timer = end - start
    times.append(proc_timer) 

    print(f"n = {n}, processing time --> {proc_timer}")


plt.figure(figsize=(8, 5))


img = mpimg.imread("imagenes/ladrillo.jpg")
plt.imshow(img, extent=[100, 1100, min(times), max(times)], aspect='auto', alpha=0.3)


scatter = plt.scatter(n_values, times, color='red', label="Tiempo de procesamiento")

plt.xlabel("Valor de n")
plt.ylabel("Tiempo de procesamiento (segundos)")
plt.title("Gráfico de Dispersión Interactivo: n vs. Tiempo de Procesamiento")
plt.legend()
plt.grid()


cursor = mplcursors.cursor(scatter, hover=True)
cursor.connect("add", lambda sel: sel.annotation.set_text(f"n={n_values[sel.index]}\nTiempo={times[sel.index]:.5f}s"))

plt.show()


